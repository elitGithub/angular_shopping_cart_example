import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { AuthService } from "./services/auth.service";
import { BehaviorSubject } from "rxjs";
import { MatSidenav } from "@angular/material/sidenav";
import { SidenavService } from "./services/sidenav.service";
import { OpenSideNavService } from "./services/open-side-nav.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: [ './app.component.css' ]
})
export class AppComponent implements OnInit, AfterViewInit {
  title = 'Shop here';

  @ViewChild('sidenav') public sidenav: MatSidenav;
  fields: any;

  constructor(public authService: AuthService, private sidenavService: SidenavService, private injectedSideNav: OpenSideNavService) {
    if (this.authService.hasAuthToken().length > 0) {
      this.authService.isAuthenticated = new BehaviorSubject<boolean>(true);
    }
  }

  ngAfterViewInit(): void {
    this.sidenavService.setSidenav(this.sidenav);
  }

  ngOnInit(): void {
    this.initApp();
  }

  private initApp() {
    this.injectedSideNav.openSideNav.addListener('open', fields => {
      this.fields = fields;
      this.sidenav.open();
    });
    //this.injectedSideNav.injectSideNav.subscribe(data => console.log(data));
  }


}
