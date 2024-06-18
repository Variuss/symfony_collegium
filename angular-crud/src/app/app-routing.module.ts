import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { ProfileComponent } from './profile/profile.component';
import { AddLessonComponent } from './lesson-add/add-lesson.component';
import { LessonDetailsComponent } from './lesson-details/lesson-details.component';
import { LessonListComponent } from './lesson-list/lesson-list.component';


const routes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'login', component: LoginComponent },
  { path: 'profile', component: ProfileComponent },
  { path: 'add', component: AddLessonComponent },
  { path: 'lessons/:id', component: LessonDetailsComponent },
  { path: 'lessons', component: LessonListComponent },
  { path: '', redirectTo: 'home', pathMatch: 'full' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
