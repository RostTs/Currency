export interface Coin {
    id: number;
    coingeckoId: string;
    symbol: string;
    name: string;
    isFavorite: boolean;
    created: string;
    price: number;
    image: string;
    priceUpdated: string;
  }