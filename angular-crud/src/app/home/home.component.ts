import { Component, OnInit } from '@angular/core';
import { StorageService } from "../_services/storage.service";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  content?: string;
  isLoggedIn = false;

  constructor(
    private storageService: StorageService
  ) {}

  ngOnInit(): void {
    this.isLoggedIn = this.storageService.isLoggedIn();

    if (this.storageService.isLoggedIn()) {
      this.content = `User logged.`;
    } else {
      this.content = `Welcome, please login.`;
    }
  }
}
