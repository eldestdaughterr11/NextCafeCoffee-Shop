"use client";
import React, { useEffect, useState } from 'react';
import { useParams, useRouter } from 'next/navigation';
import { ArrowLeft, MapPin, CreditCard, Receipt, Loader2 } from 'lucide-react';
import { motion } from 'framer-motion';

export default function OrderDetailsPage() {
  const params = useParams();
  const router = useRouter();
  const [order, setOrder] = useState<any>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchOrderDetails = async () => {
      try {
        const res = await fetch(`/api/orders/${params.id}`);
        const data = await res.json();
        if (data.order) {
          setOrder(data.order);
        }
      } catch (err) {
        console.error("Error fetching order:", err);
      } finally {
        setLoading(false);
      }
    };
    fetchOrderDetails();
  }, [params.id]);

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-cream-50">
        <Loader2 className="h-12 w-12 animate-spin text-coffee-900" />
      </div>
    );
  }

  if (!order) {
    return (
      <div className="min-h-[80vh] flex flex-col items-center justify-center">
        <Receipt className="h-16 w-16 text-coffee-200 mb-4" />
        <h2 className="text-2xl font-black text-coffee-950">Receipt Not Found</h2>
        <button onClick={() => router.back()} className="mt-4 text-[#C69276] font-bold">Go Back</button>
      </div>
    );
  }

  return (
    <div className="max-w-4xl mx-auto py-12 px-6">
      <button 
        onClick={() => router.back()}
        className="mb-8 flex items-center space-x-2 text-coffee-400 hover:text-coffee-950 transition-colors font-black uppercase text-xs tracking-widest"
      >
        <ArrowLeft className="h-4 w-4" />
        <span>Back to My Orders</span>
      </button>

      <motion.div 
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="bg-white rounded-[3rem] p-10 md:p-16 border border-coffee-50 shadow-2xl relative overflow-hidden"
      >
        {/* Receipt Header pattern */}
        <div className="absolute top-0 left-0 w-full h-4 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPScxMicgaGVpZ2h0PScxMicgdmlld0JveD0nMCAwIDEyIDEyJz48cGF0aCBkPSdNNiAwbDYgNi02IDYtNi02eicgZmlsbD0nI2Y1ZjFmNScvPjwvc3ZnPg==')] opacity-50"></div>

        <div className="text-center mb-12">
          <h1 className="text-4xl font-black text-coffee-950 mb-2 uppercase tracking-tight">Receipt</h1>
          <p className="text-coffee-400 font-bold tracking-widest text-sm uppercase">Order #ORD-{order.id.toString().padStart(4, '0')}</p>
          <p className="text-coffee-400 text-xs mt-2">{new Date(order.createdAt).toLocaleString()}</p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12 mt-8">
           <div className="bg-cream-50 p-6 rounded-3xl">
              <div className="flex items-center space-x-3 text-coffee-600 font-black text-xs uppercase tracking-widest mb-4">
                 <MapPin className="h-4 w-4" />
                 <span>Status</span>
              </div>
              <p className={`font-black uppercase ${order.status === 'completed' ? 'text-green-600' : 'text-yellow-600'}`}>
                {order.status}
              </p>
           </div>
           
           <div className="bg-cream-50 p-6 rounded-3xl">
              <div className="flex items-center space-x-3 text-coffee-600 font-black text-xs uppercase tracking-widest mb-4">
                 <CreditCard className="h-4 w-4" />
                 <span>Payment</span>
              </div>
              <p className="font-black text-coffee-950 uppercase">Cash on Delivery</p>
           </div>
        </div>

        <div className="space-y-6 mb-12">
          <h3 className="text-sm font-black text-coffee-950 uppercase tracking-widest mb-6 border-b border-coffee-50 pb-4">Items Ordered</h3>
          {order.items.map((item: any, idx: number) => (
             <div key={idx} className="flex justify-between items-center group cursor-default">
               <div className="flex items-center space-x-4">
                 <div className="w-16 h-16 bg-cream-50 rounded-2xl flex-shrink-0 overflow-hidden border border-coffee-50">
                    <img src={item.product?.image || '/images/default.png'} alt={item.product?.name} className="w-full h-full object-cover"/>
                 </div>
                 <div>
                   <p className="font-bold text-coffee-950 text-lg group-hover:text-[#C69276] transition-colors">{item.product?.name || "Unknown Product"}</p>
                   <p className="text-coffee-400 text-xs font-bold uppercase tracking-widest mt-1">Qty: {item.quantity}</p>
                 </div>
               </div>
               <span className="font-black text-coffee-950 text-xl">₱{(Number(item.price) * item.quantity).toFixed(2)}</span>
             </div>
          ))}
        </div>

        <div className="border-t-2 border-dashed border-coffee-100 pt-8 space-y-4">
           <div className="flex justify-between items-center text-sm font-bold text-coffee-400 uppercase tracking-widest">
              <span>Subtotal</span>
              <span>₱{(Number(order.total) - 45).toFixed(2)}</span>
           </div>
           <div className="flex justify-between items-center text-sm font-bold text-coffee-400 uppercase tracking-widest">
              <span>Delivery Fee</span>
              <span>₱45.00</span>
           </div>
           
           <div className="flex justify-between items-center pt-8 mt-4 border-t border-coffee-50">
              <span className="text-2xl font-black text-coffee-950 uppercase tracking-tight">Total</span>
              <span className="text-4xl font-black text-[#D4A373]">₱{(Number(order.total)).toFixed(2)}</span>
           </div>
        </div>

      </motion.div>
    </div>
  );
}
