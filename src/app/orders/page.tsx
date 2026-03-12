"use client";
import React, { useEffect, useState } from 'react';
import { ShoppingBag, Clock, ChevronRight, Loader2 } from 'lucide-react';
import { motion } from 'framer-motion';
import Link from 'next/link';
import { useRouter } from 'next/navigation';

export default function OrdersPage() {
  const router = useRouter();
  const [orders, setOrders] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchOrders = async () => {
      try {
        const name = localStorage.getItem('user_name');
        if (!name) {
          setLoading(false);
          return;
        }

        const res = await fetch('/api/orders/user', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name })
        });
        const data = await res.json();
        if (data.orders) {
          setOrders(data.orders);
        }
      } catch (err) {
        console.error("Error fetching orders:", err);
      } finally {
        setLoading(false);
      }
    };

    fetchOrders();
  }, []);

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-cream-50">
        <Loader2 className="h-12 w-12 animate-spin text-coffee-900" />
      </div>
    );
  }

  return (
    <div className="max-w-4xl mx-auto py-12 px-6">
      <div className="flex items-center space-x-4 mb-12">
        <div className="bg-[#C69276] p-4 rounded-2xl shadow-lg shadow-[#C69276]/20">
          <ShoppingBag className="text-white h-8 w-8" />
        </div>
        <div>
          <h1 className="text-4xl font-black text-coffee-950">My Orders</h1>
          <p className="text-coffee-500 font-medium">Manage and track your recent purchases</p>
        </div>
      </div>

      <div className="space-y-6">
        {orders.map((order, idx) => (
          <motion.div 
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ delay: idx * 0.1 }}
            key={order.id}
            onClick={() => router.push(`/orders/${order.id}`)}
            className="bg-white p-8 rounded-[2rem] border border-coffee-50 shadow-sm hover:shadow-xl hover:border-coffee-200 transition-all cursor-pointer group flex flex-col md:flex-row md:items-center justify-between gap-6"
          >
            <div className="flex items-center space-x-6">
               <div className="h-16 w-16 bg-cream-50 rounded-2xl flex items-center justify-center transition-colors group-hover:bg-[#C69276]/10">
                 <Clock className="text-[#C69276] h-8 w-8 transition-transform group-hover:scale-110" />
               </div>
               <div>
                 <h3 className="text-xl font-bold text-coffee-950 uppercase">#ORD-{order.id.toString().padStart(4, '0')}</h3>
                 <p className="text-coffee-400 font-medium text-sm">
                   {new Date(order.createdAt).toLocaleDateString()} • {order.items.length} Items
                 </p>
               </div>
            </div>

            <div className="flex items-center justify-between md:justify-end gap-12">
               <div className="text-right">
                 <p className="text-sm text-coffee-300 font-bold uppercase tracking-widest mb-1">Total Paid</p>
                 <p className="text-2xl font-black text-[#C69276]">₱{(Number(order.total) || 0).toFixed(2)}</p>
               </div>
               
               <div className="flex items-center space-x-4">
                 <span className={`px-5 py-2 rounded-xl font-black text-xs uppercase ${
                   order.status === 'completed' ? 'bg-green-50 text-green-600' : 
                   order.status === 'pending' ? 'bg-yellow-50 text-yellow-600' : 'bg-gray-50 text-gray-600'
                 }`}>
                   {order.status}
                 </span>
                 <button className="p-3 bg-cream-50 rounded-xl group-hover:bg-[#C69276] group-hover:text-white transition-all">
                   <ChevronRight className="h-5 w-5" />
                 </button>
               </div>
            </div>
          </motion.div>
        ))}
      </div>

      {orders.length === 0 && (
        <div className="text-center py-24 bg-white rounded-[3rem] border border-dashed border-coffee-100 flex flex-col justify-center items-center">
           <ShoppingBag className="h-16 w-16 text-coffee-100 mb-6" />
           <h2 className="text-2xl font-bold text-coffee-950 mb-2">No orders yet</h2>
           <p className="text-coffee-500 mb-6">Your coffee adventures begin here!</p>
           <Link href="/menu" className="bg-[#D4A373] text-white px-8 py-3 rounded-2xl font-black shadow-lg hover:shadow-xl transition-all">
              Go to Menu
           </Link>
        </div>
      )}
    </div>
  );
}
