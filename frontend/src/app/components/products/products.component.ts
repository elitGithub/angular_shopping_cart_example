import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../services/api.service";
import { ExternalDataSource } from "../../shared/ExternalDataSource";
import { SelectionModel } from "@angular/cdk/collections";
import { Product } from "../../interfaces/product";


@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: [ './products.component.css' ]
})
export class ProductsComponent implements OnInit {

  constructor(private apiService: ApiService) {
  }

  public displayedColumns: string[] = [ 'select', 'id', 'name', 'category', 'description', 'price' ];
  public initialSelection = [];
  public allowMultiSelect = true;
  public selection = new SelectionModel<Product>(this.allowMultiSelect, this.initialSelection);
  public dataToDisplay = [];
  public dataSource: ExternalDataSource;

  ngOnInit(): void {
    this.getList();
  }

  addData() {
    this.apiService.getProductsForm();
    // const randomElementIndex = Math.floor(Math.random() * ELEMENT_DATA.length);
    // this.dataToDisplay = [
    //   ...this.dataToDisplay,
    //   ELEMENT_DATA[randomElementIndex]
    // ];
    // this.dataSource.setData(this.dataToDisplay);
  }

  /** Whether the number of selected elements matches the total number of rows. */
  isAllSelected() {
    const numSelected = this.selection.selected.length;
    const numRows = this.dataSource.dataLength;
    return numSelected == numRows;
  }

  /** Selects all rows if they are not all selected; otherwise clear selection. */
  masterToggle() {
    this.isAllSelected() ?
      this.selection.clear() :
      this.dataSource.data.forEach(row => this.selection.select(row));
  }

  removeData() {
    this.dataToDisplay = this.dataToDisplay.slice(0, -1);
    this.dataSource.setData(this.dataToDisplay);
  }

  private getList() {
    this.apiService.getProducts().then(res => {
      this.dataToDisplay = res.data;
      this.dataSource = new ExternalDataSource(this.dataToDisplay);
    });
  }
}
