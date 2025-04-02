<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Error;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index($direction)
    {
        $checklists = Checklist::whereHas('direction', function ($query) use ($direction) {
            $query->where('id', $direction);
        })
            ->with(['blocks.possibleErrors']) // Загружаем блоки и связанные с ними ошибки
            ->get();

        // Трансформируем данные в требуемый формат
        return $checklists->map(function ($checklist) {
            return [
                'id' => (string) $checklist->id,
                'direction' => $checklist->direction->name, // Название направления
                'name' => $checklist->name,
                'blocks' => $checklist->blocks->map(function ($block) {
                    return [
                        'id' => (string) $block->id,
                        'title' => $block->title,
                        'maxScore' => $block->max_score,
                        'possibleErrors' => $block->possibleErrors->map(function ($error) {
                            return [
                                'id' => (string) $error->id,
                                'description' => $error->description,
                                'weight' => $error->weight,
                            ];
                        }),
                    ];
                }),
            ];
        });
    }

    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $data = $request->validate([
                'direction' => 'required|exists:directions,id',
                'name' => 'required|string',
                'blocks' => 'required|array',
                'blocks.*.title' => 'required|string',
                'blocks.*.maxScore' => 'required|integer',
                'blocks.*.possibleErrors' => 'required|array',
                'blocks.*.possibleErrors.*.description' => 'required|string',
                'blocks.*.possibleErrors.*.weight' => 'required|integer',
            ]);
//            dd($data); // Проверяем результат валидации
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors()); // Выводим ошибки валидации
        }
// Создаем чеклист
        $checklist = Checklist::create([
            'direction_id' => $data['direction'],
            'name' => $data['name'],
        ]);

        // Создаем блоки и связанные с ними ошибки
        foreach ($data['blocks'] as $blockData) {
            // Создаем блок
            $block = $checklist->blocks()->create([
                'title' => $blockData['title'],
                'max_score' => $blockData['maxScore'],
            ]);

            // Создаем ошибки для блока
            foreach ($blockData['possibleErrors'] as $errorData) {
                // Находим или создаем ошибку
                $error = Error::firstOrCreate([
                    'description' => $errorData['description'],
                    'weight' => $errorData['weight'],
                ]);

                // Связываем ошибку с блоком через таблицу block_errors
                $block->possibleErrors()->attach($error->id);
            }
        }

        // Возвращаем созданный чеклист с блоками и ошибками
        return response()->json($checklist->load('blocks.possibleErrors'), 201);
    }

    public function destroy($id)
    {
        Checklist::findOrFail($id)->delete();
        return response()->noContent();
    }
}
