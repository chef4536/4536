//必ず最初に読み込む
require('intersection-observer');

//Lazyload
import lozad from 'lozad';
const observer = lozad( '.lozad', {
  rootMargin: '400px 40px',
  // loaded: function(el) {
  //   el.classList.add('fade-in');
  // }
});
observer.observe();

function fixed_footer_overlay_4536() {

    const menu = document.getElementById('fixed-footer-overlay');
    if( menu === null ) return;

    let new_scroll_position = 0;
    const closeBtn = document.querySelector('.fixed-footer-close-button');
    const footer = document.getElementById('footer');

    window.addEventListener('scroll', function(e) {
        const last_scroll_position = window.scrollY;
        if(new_scroll_position < last_scroll_position && last_scroll_position > 100) {
            menu.classList.add('fade-in');
            menu.classList.remove('d-n');
        }
        new_scroll_position = last_scroll_position;
    });

    closeBtn.addEventListener('click', function(e) {
        menu.parentNode.removeChild(menu);
        closeBtn.parentNode.removeChild(closeBtn);
        footer.style.paddingBottom = '0';
    });

}

function scroll_content_4536() {

    const list = [
        'below-header-nav-menu',
        'music',
        'movie',
        'pickup',
    ];

    list.forEach(function( value ) {

        const parent = document.getElementById( value );
        if( parent === null ) return;
        const rightButton = parent.querySelector('.rightbutton');
        const leftButton = parent.querySelector('.leftbutton');
        const scroll_container = parent.querySelector('.scroll-container');
        const scroll_container_width = scroll_container.clientWidth;
        const scroll_inner = parent.querySelector('.scroll-content');
        const scroll_inner_width = scroll_inner.clientWidth;

        if(scroll_inner_width > scroll_container_width) {
            rightButton.removeAttribute('data-display');
            rightButton.classList.add('fade-in');
        }

        //右へ
        rightButton.addEventListener('click', function(e) {

            e.preventDefault();

            let i = 10;
            let t = 0;
            const right_int = setInterval(function() {
                scroll_container.scrollBy(i, 0);
                i = 10;
                t += 10;
                if( (t >= scroll_container_width) || (scroll_inner.getBoundingClientRect().right === scroll_container.getBoundingClientRect().right) ) clearInterval(right_int);
            }, 1);

        });
        //左へ
        leftButton.addEventListener('click', function(e) {

            e.preventDefault();

            let i = -10;
            let t = 0;
            const left_int = setInterval(function() {
                scroll_container.scrollBy(i, 0);
                i = -10;
                t += 10;
                if( (t >= scroll_container_width) || (scroll_inner.getBoundingClientRect().left === scroll_container.getBoundingClientRect().left) ) clearInterval(left_int);
            }, 1);

        });
        //ボタンの表示・非表示
        scroll_container.addEventListener('scroll', function(e) {

            e.preventDefault();

            if(scroll_inner.getBoundingClientRect().left < scroll_container.getBoundingClientRect().left) {
                leftButton.removeAttribute('data-display');
                leftButton.classList.add('fade-in');
            } else {
                leftButton.setAttribute('data-display', 'none');
            }
            if(scroll_inner.getBoundingClientRect().right === scroll_container.getBoundingClientRect().right) {
                rightButton.setAttribute('data-display', 'none');
            } else {
                rightButton.removeAttribute('data-display');
            }

        });
    });

}

function topButton(elmId, duration) {

    const topButton = document.getElementById(elmId);

    topButton.addEventListener('click', function(e){

        e.preventDefault();

        const begin = new Date() - 0;
        const yOffset = window.pageYOffset;
        const timer = setInterval(function() {
            let current = new Date() - begin;
            if (current > duration) {
                clearInterval(timer);
                current = duration;
            }
            //スクロール位置を単位時間で変更する
            window.scrollTo(0, yOffset * (1 - current / duration));
        }, 10);
    })

}



//実行
document.addEventListener('DOMContentLoaded', function() {

  const body = document.body;
  const header = document.getElementById('header');
  const header_h = header.offsetHeight;
  const is_mobile = window.matchMedia('screen and (max-width: 767px)');
  const to_top = document.getElementById('page-top');
  const wrapper = document.getElementById('wrapper');
  const footer = document.getElementById('footer');
  const fixed_footer = document.querySelector( '.fixed-footer' );
  const fixed_header = document.querySelector( '.fixed-header' );
  const scroll_sidebar = document.getElementById( 'scroll-sidebar' );

  let new_scroll_position = 0;

  //トップに戻る
  if( to_top !== null ) topButton('page-top', 400);

  //全体のスクロールイベント
  window.addEventListener('scroll', function(e) {

    e.preventDefault();

    const last_scroll_position = window.scrollY;

    //固定ヘッダー
    if( fixed_header !== null ) {
      if(new_scroll_position < last_scroll_position && last_scroll_position > header_h) {
        header.classList.add('fixed-top', 'body-bg-color');
        header.style.top = - header_h + 'px';
        body.style.paddingTop = header_h + 'px';
      }
      if(new_scroll_position < last_scroll_position && last_scroll_position > 200) {
        header.style.transform = 'translateY(' + header_h + 'px)';
        header.style.webkitTransform = 'translateY(' + header_h + 'px)';
      } else if (new_scroll_position > last_scroll_position) {
        header.style.transform = '';
        header.style.webkitTransform = '';
      }
      if(last_scroll_position < header_h) {
        header.classList.remove('fixed-top', 'body-bg-color');
        body.style.paddingTop = '0';
      }
    }

    //右下のトップに戻るボタン
    if( to_top !== null ) {
      if(new_scroll_position < last_scroll_position && last_scroll_position > 400) {
        to_top.classList.add('fade-in');
        to_top.classList.remove('d-n');
      } else if(last_scroll_position < 200) {
        to_top.classList.add('d-n');
      }
    }

    new_scroll_position = last_scroll_position;

  });

  //メディアクエリ
  function checkBreakPoint(is_mobile) {

    if( is_mobile.matches ) { //スマホ向け

      //固定フッターあるかどうか
      if( fixed_footer !== null ) {
        //トップに戻るボタン消す
        if( to_top !== null ) to_top.parentNode.removeChild(to_top);
        //フッターオーバーレイ
        fixed_footer_overlay_4536();
        //固定フッターのトップに戻るボタン
        if( document.getElementById('fixed-page-top-button') !== null ) {
          topButton('fixed-page-top-button', 400);
        }
      }

    } else { //PC向け

      //横スクロールコンテンツ
      scroll_content_4536();

      if( fixed_header !== null && scroll_sidebar !== null ) {
        scroll_sidebar.style.top = header_h + 20 + 'px';
      }

    }

  }

  // ブレイクポイントの瞬間に発火
  is_mobile.addListener(checkBreakPoint);

  // 初回チェック
  checkBreakPoint(is_mobile);

});



//----- 参考リンク----- //
//https://qiita.com/amamamaou/items/a29b29f5267196a5e4ea
//https://q-az.net/return-top-button-without-jquery/
