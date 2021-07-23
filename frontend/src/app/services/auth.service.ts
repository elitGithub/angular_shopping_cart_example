import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  readonly LOGIN_URL = 'http://localhost/angular_shopping_cart_example/backend/login';
  public isAuthenticated: boolean = false;

  constructor(private http: HttpClient) {
    this.isAuthenticated = this.hasAuthToken();
  }

  login(username: string, password: string) {
    return this.http.post(this.LOGIN_URL, { username, password });
  }

  hasAuthToken() {
    // TODO: implement the hasAuthToken method
    return false;
  }


}
