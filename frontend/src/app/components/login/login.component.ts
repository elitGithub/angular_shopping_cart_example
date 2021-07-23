import { Component, OnInit, Output, EventEmitter, Input } from '@angular/core';
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { AuthService } from "../../services/auth.service";
import { Router } from "@angular/router";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  form = new FormGroup({
    username: new FormControl(null, Validators.required),
    password: new FormControl(null, Validators.required),
  });

  constructor(private authService: AuthService, private router: Router) {}

  submitForm() {
    if (this.form.invalid) {
      return;
    }

    try {
      this.authService
        .login(this.form.get('username')?.value, this.form.get('password')?.value)
        .subscribe((response) => {
          this.router.navigate(['/dashboard']);
        });
    } catch (e) {
      console.warn(e);
    }

  }

  ngOnInit(): void {
  }

}
