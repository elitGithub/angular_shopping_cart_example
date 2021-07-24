import { Component, OnInit } from '@angular/core';
import { BreakpointObserver } from "@angular/cdk/layout";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

  allowedToManageUsers: boolean = false;

  constructor(private observer: BreakpointObserver) {}

  myPreferences() {
    console.log('joy');
  }

  ngOnInit(): void {
    // TODO: add permission service to check for allowed actions
    this.allowedToManageUsers = true;
  }
}
