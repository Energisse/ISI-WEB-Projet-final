
CREATE VIEW viewProduct AS 
 with orderedProduct as (
    SELECT product_id,sum(quantity) as quantity
    FROM orders o
    join orderitems oi on o.id = oi.order_id
    where o.id not in (
        SELECT order_id 
        from orderstatus 
        where status > 1
        )
    GROUP BY product_id
)
SELECT *,quantity - (SELECT IFNULL(MAX(quantity),0) FROM orderedProduct where product_id = id ) as quantity_remaining FROM products;
   

DROP VIEW viewProduct;


SELECT * FROM viewProduct;




SELECT * FROM orders o join orderitems oi on o.id =oi.order_id where o.id not in (SELECT order_id from orderstatus where status > 0);

SELECT id,quantity_remaining-(SELECT IFNULL(MAX(quantity),0) FROM orders o join orderitems oi on o.id =oi.order_id where o.id not in (SELECT order_id from orderstatus where status > 0) and product_id = p.id) as quantity_remaining FROM products p;

SELECT id,quantity_remaining FROM products p;


SELECT 
    s.*,  
    IF(s.user_id,
        JSON_OBJECT(
            'id',u.id,
            'username',u.username,
            'admin',u.admin,
            'image',u.image
        ),
        null
    ) as user,
   IF(s.user_id,
        JSON_OBJECT(
               'id',o.id,
            'delivery_add_id',o.delivery_add_id,
            'payment_type',o.payment_type,
            'price',o.price,
            'orderitems',o.orderitems,
            'status',o.status
        ),
        null
    ) as orderData
FROM Session s 
LEFT JOIN USERs u on s.user_id=u.id 
LEFT JOIN orderWithData o on s.order_id=o.id 
WHERE Session_Id = '07g5dpdbsetgveenv798o9bf1u' AND Session_Expires > '2023-01-12 22:38:41'

SELECT * FROM orderWithData;


SELECT * FROM orderWithData;

drop view orderWithData;


    CREATE VIEW orderWithData AS
    SELECT 
            o.*,
            ( SELECT 
                sum(price*oi.quantity)
                FROM products p join orderitems oi
                on p.id = oi.product_id
                where oi.order_id = o.id
            ) as price,
            ( SELECT 
                JSON_OBJECT(
                    'id', d.id,
                    'forename', d.forename,
                    'surname', d.surname,
                    'add1', d.add1,
                    'add2', d.add2,
                    'city', d.city,
                    'postcode', d.postcode,
                    'phone', d.phone,
                    'email', d.email,
                    'user_id', d.user_id,
                    'previous_id', d.previous_id
                    ) 
                FROM delivery_addresses d
                where o.delivery_add_id = d.id
            ) as delyveryAddress,  
            (
                SELECT 
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'order_id',oi.order_id,
                            'product_id',oi.product_id,
                            'quantity',oi.quantity,
                            'product', JSON_OBJECT(
                                    'id',p.id,
                                    'cat_id',p.cat_id,
                                    'name',p.name,
                                    'description',p.description,
                                    'image',p.image,
                                    'price',p.price,
                                    'quantity',p.quantity,
                                    'quantity_remaining',p.quantity_remaining
                                ) 
                        ) 
                    ) 
                FROM  orderitems oi 
                join viewProduct p on  p.id = oi.product_id 
                where o.id = oi.order_id
            ) as orderitems,
            (
                SELECT 
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'status',os.status,
                            'order_id',os.order_id,
                            'date',os.date
                        )
                    ) 
                FROM orderStatus os 
                where o.id = os.order_id  
            ) as statusHistory,
            (
                SELECT 
                    os.status
                FROM orderStatus os 
            where o.id= os.order_id  
            and date = (   
                SELECT 
                    Max(date)
                FROM orderStatus os  
                where o.id= os.order_id 
                ) ORDER BY status DESC LIMIT 1
            ) as status,
            IFNULL((
                SELECT SUM(quantity) FROM orderitems oi where oi.order_id=o.id
            ),0) as quantity
            FROM orders o
            order by id desc;




        
     

     SELECT * FROM orderWithData o where o.user_id = 1 and o.status != 0;


     select sum(quantity + 5) from orderitems where order_id=31 and product_id:=product_id


     SELECT id from orders where id not in(SELECT distinct(order_id)  from orderstatus where status > 0 ) and id = 1;