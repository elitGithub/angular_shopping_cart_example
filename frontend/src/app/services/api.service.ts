import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { ConfigService } from "./config.service";
import { AuthService } from "./auth.service";

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private appPath: any;
  private readonly token: string;

  constructor(private http: HttpClient, private configService: ConfigService, private authService: AuthService) {
    this.token = this.authService.hasAuthToken();
    this.appPath = this.configService.getApiUrl();

  }

  getProducts() {
    return [];
  }

  getCategories() {
    return [];
  }

  getUsers() {
    return [];
  }

  async getDashboard() {
    const headers: HttpHeaders = new HttpHeaders()
      .set('Authorization', `Bearer ${ this.token }`);
    return await this.http.get(`${ this.appPath }`, { 'headers': headers }).toPromise();
  }
}
