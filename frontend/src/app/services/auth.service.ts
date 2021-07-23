import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { BehaviorSubject } from "rxjs";
import { tap } from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  readonly LOGIN_URL = 'http://myshop.eli/login';
  public isAuthenticated = new BehaviorSubject<boolean>(false);

  constructor(private http: HttpClient) {
    const token = this.hasAuthToken();
  }

  login(username: string, password: string) {
    return this.http.post(this.LOGIN_URL, { username, password }).pipe(
      tap((response: any) => {
        if (response.success) {
          this.isAuthenticated.next(true);
          localStorage.setItem('auth_token', response.token);
        } else {
          throw new Error(response.message);
        }
      })
    );
  }

  hasAuthToken() {
    return localStorage.getItem('auth_token');
  }


}
