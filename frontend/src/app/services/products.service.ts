import { Injectable } from '@angular/core';
  import { Observable, of } from "rxjs";
  import { PRODUCTS } from '../interfaces/mock-products';
  import { Product } from '../interfaces/Product';
@Injectable({
  providedIn: 'root'
})
export class ProductsService {

  constructor() {
  }

  getAllProducts(): Observable<Product[]> {
    return of(PRODUCTS);
  }
}
