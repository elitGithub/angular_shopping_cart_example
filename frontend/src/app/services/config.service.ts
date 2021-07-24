import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';
import { environment as prod } from '../../environments/environment.prod';
import { isDevMode } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ConfigService {

  constructor() {
  }

  getApiUrl() {
    if (isDevMode()) {
      return environment.apiPath;
    } else {
      return prod.apiPath;
    }
  }

}
