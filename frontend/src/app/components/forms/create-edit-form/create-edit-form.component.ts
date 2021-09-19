import { Component, Input, OnInit, ViewChild, ViewEncapsulation } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from "@angular/forms";
import { Observable } from "rxjs";
import { MatSidenav } from "@angular/material/sidenav";
import { HttpHeaders } from "@angular/common/http";
import { checkResponse, createApiResponse } from "../../../utils/utils";
import { ApiService } from "../../../services/api.service";

@Component({
  selector: 'app-create-edit-form',
  templateUrl: './create-edit-form.component.html',
  styleUrls: ['./create-edit-form.component.css'],
  encapsulation: ViewEncapsulation.None,
})
export class CreateEditFormComponent implements OnInit {

  formGroup: FormGroup;
  titleAlert: string = 'This field is required';
  @ViewChild('rightSidenav') public sidenav: MatSidenav;
  public fields;
  public title;
  private emailregex: RegExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  constructor(private formBuilder: FormBuilder, private apiService: ApiService) {
  }

  ngOnInit(): void {
  }

  createForm() {
    let group = {}
    this.fields.forEach(field => {
      group[field.name] = new FormControl('');
    });
    this.formGroup = new FormGroup(group);
    this.setChangeValidate();
  }

  setChangeValidate() {
    console.log('I will validate');
    // TODO dynamic validators!
    // this.formGroup.get('validate').valueChanges.subscribe(
    //   (validate) => {
    //     if (validate == '1') {
    //       this.formGroup.get('name').setValidators([Validators.required, Validators.minLength(3)]);
    //       this.titleAlert = "You need to specify at least 3 characters";
    //     } else {
    //       this.formGroup.get('name').setValidators(Validators.required);
    //     }
    //     this.formGroup.get('name').updateValueAndValidity();
    //   }
    // )
  }

  get name() {
    return this.formGroup.get('name') as FormControl;
  }

  checkPassword(control) {
    let enteredPassword = control.value
    let passwordCheck = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/;
    return (!passwordCheck.test(enteredPassword) && enteredPassword) ? { 'requirements': true } : null;
  }

  checkInUseEmail(control) {
    // mimic http database access
    let db = ['tony@gmail.com'];
    return new Observable(observer => {
      setTimeout(() => {
        let result = (db.indexOf(control.value) !== -1) ? { 'alreadyInUse': true } : null;
        observer.next(result);
        observer.complete();
      }, 4000)
    })
  }

  getErrorEmail() {
    return this.formGroup.get('email').hasError('required') ? 'Field is required' :
      this.formGroup.get('email').hasError('pattern') ? 'Not a valid email address' :
        this.formGroup.get('email').hasError('alreadyInUse') ? 'This email address is already in use' : '';
  }

  open() {
    this.apiService.getProductsForm()
      .then(res => {
        if (checkResponse(res)) {
          this.fields = res.data['fields'];
          this.title = res.data['title'];
          this.createForm();
          console.log(res.data)
        }
      })
      .catch(err => console.warn(err));
    this.sidenav.open();
  }

  close() {
    this.sidenav.close();
  }

  getErrorPassword() {
    return this.formGroup.get('password').hasError('required') ? 'Field is required (at least eight characters, one uppercase letter and one number)' :
      this.formGroup.get('password').hasError('requirements') ? 'Password needs to be at least eight characters, one uppercase letter and one number' : '';
  }

  onSubmit(post) {
    console.log(post);
  }

}
