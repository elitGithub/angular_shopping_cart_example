import { Component, OnInit } from '@angular/core';
import { Product } from "../../interfaces/Product";
import { ProductsService } from "../../services/products.service";

@Component({
  selector: 'app-products-list',
  templateUrl: './products-list.component.html',
  styleUrls: ['./products-list.component.css']
})
export class ProductsListComponent implements OnInit {
  products: Product[] = [];

  constructor(private productService: ProductsService) {
    this.productService.getAllProducts().subscribe(products => this.products = products);
  }

  ngOnInit(): void {
  }

  addToCart(productId: any) {
    console.log(productId);
  }

  addToWishlist(productId: any) {
    console.log(productId);
  }
}
