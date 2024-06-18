import {Component, OnInit} from '@angular/core';
import { Lesson } from '../models/lesson.model';
import { LessonService } from '../_services/lesson.service';
import { StorageService } from '../_services/storage.service';

@Component({
  selector: 'app-add-lesson-add',
  templateUrl: './add-lesson.component.html',
  styleUrls: ['./add-lesson.component.css'],
})
export class AddLessonComponent implements OnInit {
  lesson: Lesson = {
    topic: '',
    content: ''
  };
  submitted = false;
  isLoggedIn = false;

  constructor(
    private lessonService: LessonService,
    private storageService: StorageService
  ) {}

  ngOnInit(): void {
    if (this.storageService.isLoggedIn()) {
      this.isLoggedIn = true;
    }
  }

  saveLesson(): void {
    const data = {
      topic: this.lesson.topic,
      content: this.lesson.content
    };

    this.lessonService.create(data).subscribe({
      next: (res) => {
        console.log(res);
        this.submitted = true;
      },
      error: (e) => console.error(e)
    });
  }

  newLesson(): void {
    this.submitted = false;
    this.lesson = {
      topic: '',
      content: ''
    };
  }
}
