import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../services/api.service";
import { ApiResponse } from "../../interfaces/api-response";

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

  async ngOnInit() {
    this.buildForm(await this.fetchDashboard());

  }

  buildForm(response: ApiResponse) {
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
