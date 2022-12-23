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
  
  constructor(private service:CoinsService) {}
  
  ngOnInit() {
      this.service.getCoins()
        .subscribe(response => {
          this.coins = response;         
        });
  }
}
