import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../services/api.service";

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: [ './dashboard.component.css' ]
})
export class DashboardComponent implements OnInit {
  isLoading: boolean = false;
  cards = [];

  constructor(private apiService: ApiService) {
  }

  ngOnInit() {
    this.fetchDashboard().then(res => this.buildForm(res));

  }

  buildForm(response) {
    if (response.hasOwnProperty('success') && response.hasOwnProperty('data')) {
      if (response.success) {
        this.cards = response.data;
        this.isLoading = false;
      }
    }
  }

  fetchDashboard() {
    this.isLoading = true;
    return this.apiService.getDashboard();
  }


}
