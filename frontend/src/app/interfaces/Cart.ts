import { Product } from "./Product";

export interface Cart {
  quantity: number;
  products: Product[];
  customerId?: string;
}
