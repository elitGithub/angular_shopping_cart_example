import { Component, OnInit } from '@angular/core';
import { BreakpointObserver } from "@angular/cdk/layout";
import { User } from "../../interfaces/user";
import { AuthService } from "../../services/auth.service";
import { BehaviorSubject } from "rxjs";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

  public allowedToManageUsers: boolean = false;
  public user: User;

  constructor(private observer: BreakpointObserver, private authService: AuthService) {}


  myPreferences() {
    console.log('joy');
  }

  ngOnInit(): void {
    // TODO: add permission service to check for allowed actions
    // TODO: add the user data to the form.
    this.allowedToManageUsers = true;
    const user = this.authService.getUser();
    if (user) {
      this.user = user;
    }
    console.log(this.authService.getUserData().then(res => this.authService.createApiResponse(res)).then(res => {
      if (res.success) {
        return this.user = res.data['user'];
      } else {
        this.authService.isAuthenticated = new BehaviorSubject<boolean>(false);
        this.authService.setToken(null);
      }
    }));
  }
}
