import { Injectable, Output } from '@angular/core';
import { EventEmitter } from "events";

@Injectable({
  providedIn: 'root'
})
export class OpenSideNavService {

  @Output() openSideNav: EventEmitter = new EventEmitter();
  constructor() { }
}
