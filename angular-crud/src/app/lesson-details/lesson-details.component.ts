import { Component, Input, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Lesson } from '../models/lesson.model';
import { LessonService } from '../_services/lesson.service';

@Component({
  selector: 'app-lesson-details',
  templateUrl: './lesson-details.component.html',
  styleUrls: ['./lesson-details.component.css'],
})
export class LessonDetailsComponent implements OnInit {
  @Input() viewMode = false;

  @Input() currentLesson: Lesson = {
    topic: '',
    content: ''
  };

  message = '';

  constructor(
    private lessonService: LessonService,
    private route: ActivatedRoute,
    private router: Router
  ) {}

  ngOnInit(): void {
    if (!this.viewMode) {
      this.message = '';
      this.getLesson(this.route.snapshot.params['id']);
    }
  }

  getLesson(id: string): void {
    this.lessonService.get(id).subscribe({
      next: (data) => {
        this.currentLesson = data;
        console.log(data);
      },
      error: (e) => console.error(e)
    });
  }

  updateLesson(): void {
    this.message = '';

    this.lessonService
      .update(this.currentLesson.id, this.currentLesson)
      .subscribe({
        next: (res) => {
          console.log(res);
          this.message = res.message
            ? res.message
            : 'This lesson was updated successfully!';
        },
        error: (e) => console.error(e)
      });
  }

  deleteLesson(): void {
    this.lessonService.delete(this.currentLesson.id).subscribe({
      next: (res) => {
        console.log(res);
        this.router.navigate(['/lessons']);
      },
      error: (e) => console.error(e)
    });
  }

  getBack():void {
    this.router.navigate(['/lessons']);
  }
}
