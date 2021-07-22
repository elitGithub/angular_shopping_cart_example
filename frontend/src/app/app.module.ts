import { CUSTOM_ELEMENTS_SCHEMA, NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AngularMaterialModule } from './angular-material.module';
import { FlexLayoutModule } from "@angular/flex-layout";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { DashboardComponent } from './components/dashboard/dashboard.component';
import { ProductsListComponent } from './components/products-list/products-list.component';
import { ProductComponent } from './components/products-list/product/product.component';
import { CategoriesListComponent } from './components/categories-list/categories-list.component';
import { CategoryComponent } from './components/categories-list/category/category.component';


@NgModule({
  declarations: [
    AppComponent,
    DashboardComponent,
    ProductsListComponent,
    ProductComponent,
    CategoriesListComponent,
    CategoryComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    AngularMaterialModule,
    FlexLayoutModule,
    FormsModule,
    ReactiveFormsModule
  ],
  providers: [],
  bootstrap: [AppComponent],
  schemas: [CUSTOM_ELEMENTS_SCHEMA]
})
export class AppModule { }
