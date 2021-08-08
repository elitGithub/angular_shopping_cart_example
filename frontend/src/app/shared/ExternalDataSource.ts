import { DataSource, SelectionModel } from "@angular/cdk/collections";
import { Observable, ReplaySubject } from "rxjs";
import { Product } from "../interfaces/product";

export class ExternalDataSource extends DataSource<Product> {
  private _dataStream = new ReplaySubject<Product[]>();
  public dataLength: number;

  public data: Product[];

  constructor(initialData: Product[]) {
    super();
    this.dataLength = initialData.length;
    this.setData(initialData);
  }

  connect(): Observable<Product[]> {
    return this._dataStream;
  }

  disconnect() {}

  setData(data: Product[]) {
    this._dataStream.next(data);
    this.data = data;
  }

}
