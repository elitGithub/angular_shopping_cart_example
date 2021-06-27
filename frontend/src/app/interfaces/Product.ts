export interface Product {
  id: number;
  title: string;
  price: number;
  image: string;
  category: string;
  inStock: boolean;
  description?: string;
  onSale?: boolean;
  saleText?: string;
}

