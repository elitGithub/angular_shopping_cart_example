import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { BehaviorSubject } from "rxjs";
import { ApiResponse } from "../interfaces/api-response";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  // TODO: move this to config
  readonly LOGIN_URL = 'http://myshop.eli/login';
  public isAuthenticated = new BehaviorSubject<boolean>(false);
  public token = '';

  constructor(private http: HttpClient) {
    this.token = this.hasAuthToken();
  }

  createApiResponse(response: any): ApiResponse {
    const apiResponse: ApiResponse = { success: false, message: '', data: [{}] };
    if (!response.hasOwnProperty('success')) {
      throw new Error('broken response');
    }

    apiResponse.success = response.success;


    if (response.hasOwnProperty('data')) {
      apiResponse.data = response.data;
    }

    if (response.hasOwnProperty('message')) {
      apiResponse.message = response.message;
    }

    return apiResponse;

  }

  getLoginForm() {
    return this.http.get(this.LOGIN_URL).toPromise().then(res => this.createApiResponse(res));
  }

  login(username: string, password: string) {
    return this.http.post(this.LOGIN_URL, { username, password }).toPromise().then(res => this.createApiResponse(res));
  }

  hasAuthToken() {
    return localStorage.getItem('auth_token') ?? '';
  }


  setToken(token) {
    this.token = token;
    localStorage.setItem('auth_token', token);
  }
}
