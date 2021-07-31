import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: [ './dashboard.component.css' ]
})
export class DashboardComponent implements OnInit {
  isLoading: boolean = false;
  cards = [];

  constructor() {
  }

  ngOnInit() {
    this.fetchDashboard();
    console.log(this.isLoading);
  }

  fetchDashboard() {
    this.isLoading = true;
  }


}
