import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from "@angular/router";
import { DashboardComponent } from "./dashboard.component";
import { HttpClientModule } from "@angular/common/http";
import { CardComponent } from './card/card.component';
import { DashboardLoadingComponent } from './dashboard-loading/dashboard-loading.component';
import { NgxChartsModule } from "@swimlane/ngx-charts";
import { MaterialModule } from "../../material.module";
import { SharedModule } from "../../shared/shared.module";

const routes: Routes = [
  {
    path: '',
    component: DashboardComponent
  }
];


@NgModule({
  declarations: [ DashboardComponent, CardComponent, DashboardLoadingComponent ],
  imports: [
    MaterialModule,
    CommonModule,
    RouterModule.forChild(routes),
    HttpClientModule,
    NgxChartsModule,
    SharedModule
  ]
})
export class DashboardModule {
}
