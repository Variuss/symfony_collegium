<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api', name: 'api_')]
class LessonController extends AbstractController
{
    private string $acceptedContentType = 'application/json';

    #[Route('/lessons', name: 'api_lessons_index', methods: 'get')]
    public function index(LessonRepository $lessonRepository): JsonResponse
    {
        $lessons = $lessonRepository->findAll();
        $data = [];

        foreach ($lessons as $lesson) {
            $data[] = [
                'id' => $lesson->getId(),
                'topic' => $lesson->getTopic(),
                'content' => $lesson->getContent()
            ];
        }

        return $this->json($data);
    }

    #[Route('/lessons', name: 'api_lessons_add', methods: 'post')]
    public function add(LessonRepository $lessonRepository, Request $request): JsonResponse
    {
        $lesson = new Lesson();
        $content = json_decode($request->getContent());

        if ($request->headers->get('Content-Type') != $this->acceptedContentType) {
            return $this->json(
                [
                    'message' => 'Content type ' . $request->headers->get('Content-Type') . ' not supported.'
                ], 415);
        }
        
        try {
            $lesson->setTopic($content->topic);
            $lesson->setContent($content->content);
            $lessonRepository->save($lesson);
        } catch (\Exception $e) {
            return $this->json(['message' => 'Request data is invalid.'], 400);
        }

        return $this->json(['message' => 'New Lesson has been added successfully with id ' . $lesson->getId()]);
    }

    #[Route('/lessons/{id}', name: 'api_lessons_show', methods: 'get')]
    public function show(LessonRepository $lessonRepository, int $id): JsonResponse
    {
        $lesson = $lessonRepository->find($id);
        if (!$lesson) {
            return $this->json(['message' => 'No Lesson found for id' . $id], 404);
        }

        $data =  [
            'id' => $lesson->getId(),
            'topic' => $lesson->getTopic(),
            'content' => $lesson->getContent()
        ];

        return $this->json($data);
    }

    #[Route('/lessons/{id}', name: 'api_lessons_edit', methods: 'put')]
    public function edit(
        EntityManagerInterface $entityManager,
        LessonRepository $lessonRepository,
        Request $request,
        int $id
    ): JsonResponse
    {
        if ($request->headers->get('Content-Type') != $this->acceptedContentType) {
            return $this->json(
                [
                    'message' => 'Content type ' . $request->headers->get('Content-Type') . ' not supported.'
                ], 415);
        }

        $lesson = $lessonRepository->find($id);
        if (!$lesson) {
            return $this->json(['message' => 'No Lesson found for id' . $id], 404);
        }

        $content = json_decode($request->getContent());
        try {
            $lesson->setTopic($content->topic);
            $lesson->setContent($content->content);
            $entityManager->flush();
        } catch (\Exception $e) {
            return $this->json(['message' => 'Request data is invalid.'], 400);
        }

        return $this->json(['message' => 'Lesson with id: ' . $lesson->getId() . ' has been edited successfully.']);
    }

    #[Route('/lessons/{id}', name: 'api_lessons_delete', methods: 'delete')]
    public function delete(LessonRepository $lessonRepository, int $id): JsonResponse
    {
        $lesson = $lessonRepository->find($id);
        if (!$lesson) {
            return $this->json(['message' => 'No Lesson found for id' . $id], 404);
        }

        $lessonRepository->delete($lesson);

        return $this->json(['message' => 'Deleted a Lesson successfully with id ' . $id]);
    }
}