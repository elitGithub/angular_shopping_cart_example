import { Component, Input, OnInit, Output, EventEmitter } from '@angular/core';
import { Product } from "../../interfaces/Product";

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.css']
})
export class ProductComponent implements OnInit {

  @Input() product: Product;
  @Output() addToCart = new EventEmitter();
  @Output() addToWishList = new EventEmitter();
  constructor() { }

  ngOnInit(): void {
  }

  onAddToCart() {
    this.addToCart.emit(this.product.id);
  }

  onAddToWishList() {
    this.addToWishList.emit(this.product.id);
  }
}
