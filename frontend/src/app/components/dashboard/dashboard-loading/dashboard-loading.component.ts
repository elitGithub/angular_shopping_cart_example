import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-dashboard-loading',
  templateUrl: './dashboard-loading.component.html',
  styleUrls: ['./dashboard-loading.component.css']
})
export class DashboardLoadingComponent implements OnInit {

  @Input() isLoading: boolean = false;
  constructor() { }

  ngOnInit(): void {
    console.log(this.isLoading);
  }

}
