import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { ApiService } from "../../services/api.service";
import { ExternalDataSource } from "../../shared/ExternalDataSource";
import { SelectionModel } from "@angular/cdk/collections";
import { Product } from "../../interfaces/product";
import { checkResponse } from "../../utils/utils";
import { SidenavService } from "../../services/sidenav.service";
import { MatSidenav } from "@angular/material/sidenav";


@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: [ './products.component.css' ]
})
export class ProductsComponent implements OnInit, AfterViewInit {

  @ViewChild('sidenav') public sidenav: MatSidenav;

  constructor(private apiService: ApiService, private sideNavService: SidenavService) {
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

  toggleSideNav() {
    this.sideNavService.toggle();
  }

  ngAfterViewInit(): void {
    this.sideNavService.setSidenav(this.sidenav);
  }

  addData() {
    this.apiService.getProductsForm()
      .then(res => {
        if (checkResponse(res)) {
          this.buildForm(res.data);
        }
      })
      .catch(err => console.warn(err));
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

  private buildForm(data: [ {} ]) {
    this.toggleSideNav()
    console.log(data);
  }
}
