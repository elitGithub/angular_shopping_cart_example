import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NavbarComponent } from './layouts/navbar/navbar.component';
import { LayoutModule } from '@angular/cdk/layout';
import { NotFoundComponent } from './components/not-found/not-found.component';
import { HttpClientModule } from "@angular/common/http";
import { LoginComponent } from './components/login/login.component';
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { CategoriesComponent } from './components/categories/categories.component';
import { UsersComponent } from './components/users/users.component';
import { MaterialModule } from "./material.module";
import { SharedModule } from "./shared/shared.module";

@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    NotFoundComponent,
    LoginComponent,
    CategoriesComponent,
    UsersComponent
  ],
  imports: [
    MaterialModule,
    BrowserModule,
    BrowserAnimationsModule,
    LayoutModule,
    AppRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    SharedModule,
  ],
  providers: [],
  bootstrap: [ AppComponent ]
})
export class AppModule {
}
