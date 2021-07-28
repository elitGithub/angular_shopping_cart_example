import { AfterViewInit, Component, ViewChild } from '@angular/core';
import { AuthService } from "./services/auth.service";
import { BehaviorSubject } from "rxjs";
import { BreakpointObserver } from "@angular/cdk/layout";
import { MatSidenav } from "@angular/material/sidenav";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: [ './app.component.css' ]
})
export class AppComponent {
  title = 'Shop here';


  constructor(public authService: AuthService) {
    if (this.authService.hasAuthToken().length > 0) {
      this.authService.isAuthenticated = new BehaviorSubject<boolean>(true);
    }
  }


}
