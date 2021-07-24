import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { BehaviorSubject } from "rxjs";
import { ApiResponse } from "../interfaces/api-response";
import { ConfigService } from "./config.service";
import { User } from "../interfaces/user";
// TODO:
// stage 1 check if has token
// stage 2 verify if token is valid
// if valid - get user data (BE - need to return user data on "user is logged in"
// Else - usual login, no user data
@Injectable({
  providedIn: 'root'
})
export class AuthService {

  public isAuthenticated = new BehaviorSubject<boolean>(false);
  public token = '';
  private LOGIN_URL = '';
  public user: User;

  constructor(private http: HttpClient, private configService: ConfigService) {
    this.token = this.hasAuthToken();
    this.LOGIN_URL = this.configService.getApiUrl();
  }

  createApiResponse(response: any): ApiResponse {
    const apiResponse: ApiResponse = { success: false, message: '', data: [ {} ] };
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

  setUser(data) {
    this.user = data;
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

  getUser() {
    return this.user;
  }
}
