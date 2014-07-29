**Dikkat** : Proje hala geliştirme aşamasında ama test edebilirsiniz.

Demo : 

    $ curl aktuel.herokuapp.com

Eğer siz de heroku'ya gönderecekseniz heroku deploy öncesi 

    $ heroku addons:docs memcachier
    $ heroku addons:add scheduler:standard

TODO

 - Veriler istek anında değil öncesinde zamanlanmış görevlerle hazırlanacak
