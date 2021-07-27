import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { BehaviorSubject } from "rxjs";
import { ApiResponse } from "../interfaces/api-response";
import { ConfigService } from "./config.service";
import { User } from "../interfaces/user";
import { CookieService } from "ngx-cookie-service";
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
  public appPath = '';
  public token = '';
  private loginUrl = '';
  private isLoggedInUrl = '';
  public user: User;

  constructor(private http: HttpClient, private configService: ConfigService, private cookieService: CookieService) {
    this.token = this.hasAuthToken();
    this.appPath = this.configService.getApiUrl();
    this.loginUrl = `${ this.appPath }login`;
    this.isLoggedInUrl = `${ this.appPath }isLoggedIn`;

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

  isLoggedIn() {
    return this.http.post(this.isLoggedInUrl, { token: this.token }).toPromise().then(res => this.createApiResponse(res));
  }

  setUser(data) {
    this.user = data;
  }

  login(username: string, password: string) {
    return this.http.post(this.loginUrl, { username, password }).toPromise().then(res => this.createApiResponse(res));
  }

  getUserData() {
    const headers: HttpHeaders = new HttpHeaders()
      .set('Authorization', `Bearer ${ this.token }`);
    return this.http.get(`${ this.appPath }/getUserData`, { 'headers': headers }).toPromise().then(res => this.createApiResponse(res));
  }

  hasAuthToken() {
    return this.cookieService.get('auth_token');
  }


  setToken(token) {
    this.token = token;
    this.cookieService.set('auth_token', token);
  }

  getUser() {
    if (this.user) {
      return this.user;
    }
    return null;
  }
}
