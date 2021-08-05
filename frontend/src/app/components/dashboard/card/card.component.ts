import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-card',
  templateUrl: './card.component.html',
  styleUrls: ['./card.component.css']
})
export class CardComponent implements OnInit {

  @Input() cards;
  @Input() metaData;
  single: any[];
  view: [number, number] = [700, 400];

  colorScheme = {
    domain: []
  };
  cardColor: string;

  constructor() { }

  ngOnInit(): void {
    this.cardColor = this.metaData.primaryColor;
    this.cardsData(this.cards);
  }

  cardsData(cards) {
    this.cards.forEach(card => {
      this.colorScheme.domain.push(card.color);
    });
    this.single = cards;
  }
}
