import { Component } from '@angular/core';
import { AuthService } from "./services/auth.service";
import { BehaviorSubject } from "rxjs";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'Shop here';
  constructor(public authService: AuthService) {
    if (this.authService.hasAuthToken()) {
      this.authService.isAuthenticated = new BehaviorSubject<boolean>(true);
    }
  }
}
