import { Component, OnInit } from '@angular/core';
import { CoinsService } from './coins.service';
import { Coin } from '../interfaces/coin.interface';

@Component({
  selector: 'app-coins',
  templateUrl: './coins.component.html',
  styleUrls: ['./coins.component.scss']
})
export class CoinsComponent implements OnInit{
  coins: Coin[];;
  private pageSize: number;
  private page: number;
  
  constructor(private service:CoinsService) {}
  
  ngOnInit() {
      this.service.getCoins(1,2)
        // .subscribe(response => {
        //   this.coins = response;         
        // });
  }
}
