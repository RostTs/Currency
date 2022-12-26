import { Component, OnInit } from '@angular/core';
import { CoinsService } from './coins.service';
import { Coin } from '../interfaces/coin.interface';

@Component({
  selector: 'app-coins',
  templateUrl: './coins.component.html',
  styleUrls: ['./coins.component.scss']
})
export class CoinsComponent implements OnInit{
  coins: Coin[];
  pageSize: number = 10;
  page: number;

  constructor(private service:CoinsService) {}

  ngOnInit() {
      this.setCoins();
  }

  setCoins() {
    this.service.getCoins(this.pageSize)
      .subscribe(response => {
        this.coins = response.body;
        console.log(response.headers.has('Range'));
      });
    // this.coins = this.service.getCoins();
  }
}
