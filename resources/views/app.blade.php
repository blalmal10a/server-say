<!DOCTYPE html><html><head><title>SAY</title><meta charset=utf-8><meta name=description content="Salvation Army Youth"><meta name=format-detection content="telephone=no"><meta name=msapplication-tap-highlight content=no><meta name=viewport content="user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1,width=device-width"><link rel=icon type=image/png sizes=128x128 href=/icons/favicon-128x128.png><link rel=icon type=image/png sizes=96x96 href=/icons/favicon-96x96.png><link rel=icon type=image/png sizes=32x32 href=/icons/favicon-32x32.png><link rel=icon type=image/png sizes=16x16 href=/icons/favicon-16x16.png><link rel=icon type=image/ico href=/favicon.ico><style>body {
        margin: 0;
      }
      .loader {
        position: relative;
        width: 108px;
        display: flex;
        justify-content: space-between;
      }
      .loader::after,
      .loader::before {
        content: "";
        display: inline-block;
        width: 48px;
        height: 48px;
        background-color: #fff;
        background-image: radial-gradient(
          circle 14px,
          #0d161b 100%,
          transparent 0
        );
        background-repeat: no-repeat;
        border-radius: 50%;
        animation: eyeMove 10s infinite, blink 10s infinite;
      }
      @keyframes eyeMove {
        0%,
        10% {
          background-position: 0px 0px;
        }
        13%,
        40% {
          background-position: -15px 0px;
        }
        43%,
        70% {
          background-position: 15px 0px;
        }
        73%,
        90% {
          background-position: 0px 15px;
        }
        93%,
        100% {
          background-position: 0px 0px;
        }
      }
      @keyframes blink {
        0%,
        10%,
        12%,
        20%,
        22%,
        40%,
        42%,
        60%,
        62%,
        70%,
        72%,
        90%,
        92%,
        98%,
        100% {
          height: 48px;
        }
        11%,
        21%,
        41%,
        61%,
        71%,
        91%,
        99% {
          height: 18px;
        }
      }

      #wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100svh;
        width: 100%;
        background-color: #263038;
      }</style>  <script type="module" crossorigin src="/assets/index.42c4e234.js"></script>
  <link rel="stylesheet" href="/assets/index.78daa7bb.css">
</head><body><div id=wrapper><span class=loader></span></div><div id=q-app></div></body></html>