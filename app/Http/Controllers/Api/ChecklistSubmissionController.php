<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChecklistBlock;
use App\Models\ChecklistSubmission;
use App\Models\Error;
use App\Models\Manager;
use Illuminate\Http\Request;

class ChecklistSubmissionController extends Controller
{
    public function store(Request $request)
    {
        // Валидация входных данных
        $data = $request->validate([
            'checklistId' => 'required|exists:checklists,id',
            'manager' => 'required|string',
            'direction' => 'required|exists:directions,id',
            'callStatus' => 'required|in:sale,test,rejection,callback',
            'callDateTime' => 'required|date_format:Y-m-d\TH:i',
            'clientPhone' => 'required|string',
            'blocks' => 'required|array',
            'blocks.*.id' => 'required|exists:checklist_blocks,id',
            'blocks.*.errors' => 'array',
            'blocks.*.errors.*.errorId' => 'required|exists:errors,id',
            'blocks.*.errors.*.timing' => 'nullable|string',
            'blocks.*.checked' => 'required|boolean',
            'blocks.*.comment' => 'nullable|string',
            'blocks.*.score' => 'required|integer|min:0',
            'totalScore' => 'required|integer|min:0',
        ]);

        // Создаем или находим менеджера по имени
        $manager = Manager::firstOrCreate(['name' => $data['manager']]);

        // Создаем новую оценку чеклиста
        $submission = ChecklistSubmission::create([
            'checklist_id' => $data['checklistId'],
            'manager_id' => $manager->id,
            'call_status' => $data['callStatus'],
            'call_date_time' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $data['callDateTime']),
            'client_phone' => $data['clientPhone'],
            'total_score' => $data['totalScore'],
        ]);

        // Обрабатываем блоки
        foreach ($data['blocks'] as $blockData) {
            // Находим блок
            $block = ChecklistBlock::findOrFail($blockData['id']);

            // Создаем запись в таблице submission_blocks
            $submissionBlock = $submission->blocks()->create([
                'block_id' => $block->id,
                'checked' => $blockData['checked'],
                'comment' => $blockData['comment'],
                'score' => $blockData['score'],
            ]);

            // Обрабатываем ошибки
            foreach ($blockData['errors'] as $errorData) {
                // Находим ошибку
                $error = Error::findOrFail($errorData['errorId']);

                // Создаем запись в таблице submission_errors
                $submissionBlock->errors()->create([
                    'error_id' => $error->id,
                    'timing' => $errorData['timing'],
                ]);
            }
        }

        return response()->json($submission, 201);
    }

    public function indexByManager($managerName)
    {
        // Находим менеджера по имени
        $manager = Manager::where('name', $managerName)->first();

        if (!$manager) {
            return response()->json(['message' => 'Менеджер не найден'], 404);
        }

        // Получаем все оценки чеклистов для данного менеджера
        $submissions = ChecklistSubmission::with([
            'checklist',
            'manager',
            'blocks.block.possibleErrors', // Загружаем связанные блоки и возможные ошибки
            'blocks.errors.error'          // Загружаем связанные ошибки для каждого блока
        ])->where('manager_id', $manager->id)->get();

        // Трансформируем данные в нужный формат
        $formattedSubmissions = $submissions->map(function ($submission) {
            return [
                'id' => $submission->id,
                'checklistId' => $submission->checklist_id,
                'manager' => $submission->manager->name,
                'direction' => $submission->checklist->direction->name,
                'callStatus' => $submission->call_status,
                'callDateTime' => $submission->call_date_time instanceof \Carbon\Carbon
                    ? $submission->call_date_time->format('Y-m-d\TH:i') // Форматирование даты
                    : null, // Возвращаем null, если дата отсутствует
                'clientPhone' => $submission->client_phone,
                'blocks' => $submission->blocks->map(function ($submissionBlock) {
                    return [
                        'id' => $submissionBlock->block->id,
                        'title' => $submissionBlock->block->title,
                        'maxScore' => $submissionBlock->block->max_score,
                        'checked' => (bool) $submissionBlock->checked,
                        'comment' => $submissionBlock->comment,
                        'score' => $submissionBlock->score,
                        'errors' => $submissionBlock->errors->map(function ($submissionError) {
                            return [
                                'errorId' => $submissionError->error->id,
                                'description' => $submissionError->error->description,
                                'weight' => $submissionError->error->weight,
                                'timing' => $submissionError->timing,
                            ];
                        }),
                    ];
                }),
                'totalScore' => $submission->total_score,
            ];
        });

        return response()->json($formattedSubmissions);
    }

}
