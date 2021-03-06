import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { ConfigService } from "./config.service";
import { AuthService } from "./auth.service";
import { createApiResponse } from "../utils/utils";

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private readonly appPath: any;
  private token: string;

  constructor(private http: HttpClient, private configService: ConfigService, private authService: AuthService) {
    this.token = this.authService.hasAuthToken();
    this.appPath = this.configService.getApiUrl();

  }

  getProducts() {
    const headers: HttpHeaders = new HttpHeaders().set('Authorization', `Bearer ${ this.token }`);
    return this.http.get(`${ this.appPath }/products`, { 'headers': headers }).toPromise().then(res => createApiResponse(res));
  }

  getCategories() {
    return [];
  }

  getUsers() {
    return [];
  }

  getDashboard() {
    if (!this.token) {
      this.token = this.authService.hasAuthToken();
    }
    const headers: HttpHeaders = new HttpHeaders().set('Authorization', `Bearer ${ this.token }`);
    return this.http.get(`${ this.appPath }`, { 'headers': headers }).toPromise().then(res => createApiResponse(res));
  }

  getProductsForm() {
    if (!this.token) {
      this.token = this.authService.hasAuthToken();
    }
    const headers: HttpHeaders = new HttpHeaders().set('Authorization', `Bearer ${ this.token }`);
    return this.http.get(`${ this.appPath }/products-form`, { 'headers': headers }).toPromise().then(res => createApiResponse(res));
  }
}
