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
    this.fetchDashboard();
  }

  async fetchDashboard() {
    this.isLoading = true;
    await this.apiService.getDashboard();
  }


}
