import { AfterViewInit, Component, ViewChild } from '@angular/core';
import { AuthService } from "./services/auth.service";
import { BehaviorSubject } from "rxjs";
import { BreakpointObserver } from "@angular/cdk/layout";
import { MatSidenav } from "@angular/material/sidenav";
import { SidenavService } from "./services/sidenav.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: [ './app.component.css' ]
})
export class AppComponent implements AfterViewInit{
  title = 'Shop here';

  @ViewChild('sidenav') public sidenav: MatSidenav;
  constructor(public authService: AuthService, private sidenavService: SidenavService) {
    if (this.authService.hasAuthToken().length > 0) {
      this.authService.isAuthenticated = new BehaviorSubject<boolean>(true);
    }
  }

  ngAfterViewInit(): void {
    this.sidenavService.setSidenav(this.sidenav);
  }


}
