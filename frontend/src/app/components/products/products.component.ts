import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../services/api.service";
import { ExternalDataSource } from "../../shared/ExternalDataSource";
import { SelectionModel } from "@angular/cdk/collections";
import { Product } from "../../interfaces/product";
import { checkResponse } from "../../utils/utils";
import { OpenSideNavService } from "../../services/open-side-nav.service";


@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: [ './products.component.css' ]
})
export class ProductsComponent implements OnInit {
  constructor(private apiService: ApiService, private sideNavService: OpenSideNavService) {
  }

  public displayedColumns: string[] = [ 'select', 'id', 'name', 'category', 'description', 'price' ];
  public initialSelection = [];
  public allowMultiSelect = true;
  public selection = new SelectionModel<Product>(this.allowMultiSelect, this.initialSelection);
  public dataToDisplay = [];
  public dataSource: ExternalDataSource;
  public showEdit: boolean = false;

  ngOnInit(): void {
    this.getList();
  }


  addData() {
    this.showEdit = !this.showEdit;
    this.sideNavService.openSideNav.emit(this.showEdit ? 'open' : 'close');
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
