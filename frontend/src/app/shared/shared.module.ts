import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SpinnerComponent } from "../components/spinner/spinner.component";
import { CreateEditFormComponent } from "../components/forms/create-edit-form/create-edit-form.component";
import { AppModule } from "../app.module";
import { MaterialModule } from "../material.module";
import { ReactiveFormsModule } from "@angular/forms";


@NgModule({
  declarations: [
    SpinnerComponent,
    CreateEditFormComponent
  ],
  imports: [
    CommonModule,
    MaterialModule,
    ReactiveFormsModule
  ],
  exports: [
    SpinnerComponent,
    CreateEditFormComponent,
  ]
})
export class SharedModule {
}
