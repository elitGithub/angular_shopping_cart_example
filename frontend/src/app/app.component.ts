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
export class AppComponent implements AfterViewInit{
  title = 'Shop here';
  @ViewChild(MatSidenav)
  sidenav!: MatSidenav;


  constructor(private observer: BreakpointObserver, public authService: AuthService) {
    if (this.authService.hasAuthToken()) {
      this.authService.isAuthenticated = new BehaviorSubject<boolean>(true);
    }
  }

  ngAfterViewInit() {
    if (this.authService.isAuthenticated.value) {
      this.observer.observe([ '(max-width: 800px)' ]).subscribe((res) => {
        if (res.matches) {
          this.sidenav.mode = 'over';
          this.sidenav.close();
        } else {
          this.sidenav.mode = 'side';
          this.sidenav.open();
        }
      });
    }
  }

}
