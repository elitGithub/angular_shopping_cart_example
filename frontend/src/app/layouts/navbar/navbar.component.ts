import { Component, OnInit } from '@angular/core';
import { User } from "../../interfaces/user";
import { AuthService } from "../../services/auth.service";
import { BehaviorSubject } from "rxjs";
import { Router } from "@angular/router";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: [ './navbar.component.scss' ]
})
export class NavbarComponent implements OnInit {

  public allowedToManageUsers: boolean = false;
  public user: User;

  constructor(private authService: AuthService, private router: Router) {
  }


  myPreferences() {
    console.log('joy');
    console.log('llllllllll');
  }

  ngOnInit(): void {
    // TODO: add permission service to check for allowed actions
    // TODO: add the user data to the form.
    this.allowedToManageUsers = true;
    const user = this.authService.getUser();
    if (user) {
      this.user = user;
    } else {
      this.authService.getUserData()
        .then(res => this.authService.createApiResponse(res))
        .then(res => {
          if (res.success) {
            this.user = res.data['user'];
            return this.router.navigateByUrl('/dashboard');
          } else {
            this.authService.isAuthenticated = new BehaviorSubject<boolean>(false);
            this.authService.setToken(null);
            return this.router.navigateByUrl('/login');
          }
        });
    }
  }
}
