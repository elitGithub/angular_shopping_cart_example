import { Component, OnInit, Output, EventEmitter, Input } from '@angular/core';
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { AuthService } from "../../services/auth.service";
import { Router } from "@angular/router";
import { checkResponse } from '../../utils/utils';
import { BehaviorSubject } from "rxjs";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  isLoading = false;
  form = new FormGroup({
    username: new FormControl(null, Validators.required),
    password: new FormControl(null, Validators.required),
  });
  hasError: boolean = false;
  error: string = '';

  constructor(private authService: AuthService, private router: Router) {}


  ngOnInit(): void {
    this.authService
      .getLoginForm()
      .then(response => {
        if (!checkResponse(response)) {
          throw new Error('Missing required params');
        }
        return response;
      })
      .then(response => {
        if (response.data) {
          this.buildForm(response.data['fields'])
        }
      })
      .catch(e => console.warn(e));
  }

  buildForm(fields: any) {
    console.log(fields);
  }

  submitForm() {
    if (this.form.invalid) {
      return;
    }

    this.isLoading = true;
    this.authService
      .login(this.form.get('username')?.value, this.form.get('password')?.value)
      .then(res => {
        if (!checkResponse(res)) {
          this.hasError = true;
          if (res.hasOwnProperty('message')) {
            this.error = res.message;
          } else {
            this.error = 'Incorrect username or password';
          }
        } else {
          this.isLoading = false;
          this.authService.isAuthenticated = new BehaviorSubject<boolean>(true);
          this.authService.setToken(res.data['token']);
          this.router.navigateByUrl('dashboard');
        }
      })
      .catch(e => console.warn(e));

    this.isLoading = false;
    // try {
    //   this.authService
    //     .login(this.form.get('username')?.value, this.form.get('password')?.value)
    //     .subscribe((response) => {
    //       this.router.navigate(['/dashboard']);
    //     });
    // } catch (e) {
    //   console.warn(e);
    // }

  }


}
