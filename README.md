# README FILE#

# PLUGIN WORDPRESS QUẢN LÝ VÍ TIỀN ONLINE #

# Directory tree #
├── index.php <br />
└── include <br />
| ---   └── template files <br />
└── cry_assets <br />
---    └── css <br />
---    └── fonts <br />
---    └── js <br />

# API SỬ DỤNG #
1.GET CONTENT JSON TỪ BLOCKCHAIN.INFO/ADDRESS/ ĐỂ GET TRANSACTIONS INFO <br />
  Hỗ trợ get 50 transfers /1 lần với từng offset - > dễ dùng ajax để insert vào DB hơn <br />
  https://blockchain.info/address/" . $address . "?format=json&offset=0" <br />
2.GET CONTENT JSON TỪ https://api.coinbase.com/v2/exchange-rates?currency=BTC  ĐỂ LẤY TỈ LỆ ĐỔI --- FREE REQUEST <br />
CÓ THỂ SỬ DỤNG https://developers.coinbase.com/api/v2#prices ĐỂ LẤY TỈ LỆ ĐỔI CHI TIẾT -- FREE REQUEST <br />
3.PIECHART % BÉ : https://github.com/rendro/easy-pie-chart <br />
4.PIECHART LỚN : http://www.chartjs.org/  HOẶC https://developers.google.com/chart/interactive/docs/gallery/piechart#example <br />
5.AREA CHART https://jsfiddle.net/api/post/library/pure/ <br />
6.TABLES : DATATABLE ? <br />
### TIẾN HÀNH :   ###

