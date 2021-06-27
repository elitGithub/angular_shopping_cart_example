import { Injectable } from '@angular/core';
import { Observable } from "rxjs";
import { Product } from '../interfaces/Product';
import { Cart } from "../interfaces/Cart";

@Injectable({
  providedIn: 'root'
})
export class CartService {

  cart: Cart;
  constructor() { }

  addToCart(product: Product) {
    // TODO: check if item is already in the cart - if yes increase its quantity instead
    this.cart.products.push(product);
  }

}
