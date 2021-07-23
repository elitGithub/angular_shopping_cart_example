import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  public isAuthenticated: boolean = false;
  constructor() {
    this.isAuthenticated = this.hasAuthToken();
  }

  login() {
    // TODO: implement the authenticate method
    return true;
  }

  hasAuthToken() {
    // TODO: implement the hasAuthToken method
    return false;
  }


}
