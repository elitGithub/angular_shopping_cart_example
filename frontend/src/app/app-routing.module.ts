import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { NotFoundComponent } from "./components/not-found/not-found.component";
import { DashboardComponent } from "./components/dashboard/dashboard.component";
import { LoginComponent } from "./components/login/login.component";
import { ProductsComponent } from "./components/products/products.component";
import { CategoriesComponent } from "./components/categories/categories.component";
import { UsersComponent } from "./components/users/users.component";

const routes: Routes = [
  {
    path: 'dashboard',
    component: DashboardComponent,
  },
  {
    path: 'products',
    component: ProductsComponent,
  },
  {
    path: 'categories',
    component: CategoriesComponent,
  },
  {
    path: 'users',
    component: UsersComponent,
  },
  {
    path: 'login',
    component: LoginComponent,
  },
  {
    path: '',
    pathMatch: 'full',
    redirectTo: 'login',
  },
  {
    path: '**',
    component: NotFoundComponent
  }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule {
}
