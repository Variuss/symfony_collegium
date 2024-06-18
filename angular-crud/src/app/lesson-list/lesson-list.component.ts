import { Component, OnInit } from '@angular/core';
import { Lesson } from '../models/lesson.model';
import { LessonService } from '../_services/lesson.service';
import { StorageService } from '../_services/storage.service';

@Component({
  selector: 'app-lesson-list',
  templateUrl: './lesson-list.component.html',
  styleUrls: ['./lesson-list.component.css'],
})
export class LessonListComponent implements OnInit {
  lessons?: Lesson[];
  currentLesson: Lesson = {};
  currentIndex = -1;
  topic = '';

  isLoggedIn = false;

  constructor(
    private lessonService: LessonService,
    private storageService: StorageService
  ) {}

  ngOnInit(): void {
    if (this.storageService.isLoggedIn()) {
      this.isLoggedIn = true;
      this.retrieveLessons();
    }
  }

  retrieveLessons(): void {
    this.lessonService.getAll().subscribe({
      next: (data) => {
        this.lessons = data;
        console.log(data);
      },
      error: (e) => console.error(e)
    });
  }

  refreshList(): void {
    this.retrieveLessons();
    this.currentLesson = {};
    this.currentIndex = -1;
  }

  setActiveLesson(lesson: Lesson, index: number): void {
    this.currentLesson = lesson;
    this.currentIndex = index;
  }
}
