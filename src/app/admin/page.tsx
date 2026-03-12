"use client";
import React, { useState, useEffect } from 'react';
import { ShoppingBag, Users as UsersIcon, Package, DollarSign, Clock, CheckCircle } from 'lucide-react';
import AdminSidebar from '@/components/AdminSidebar';

export default function AdminDashboardPage() {
  const [stats, setStats] = useState({
    totalSales: 0,
    totalOrders: 0,
    totalProducts: 0,
    totalUsers: 0,
    recentOrders: [] as any[]
  });
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // We'll combine fetches to build dashboard stats
    const fetchDashboardData = async () => {
      try {
        const [ordersRes, productsRes, usersRes] = await Promise.all([
          fetch('/api/admin/orders'),
          fetch('/api/products'),
          fetch('/api/admin/users')
        ]);
        
        const orders = ordersRes.ok ? await ordersRes.json() : [];
        const products = productsRes.ok ? await productsRes.json() : [];
        const users = usersRes.ok ? await usersRes.json() : [];

        // Calculate
        const totalSales = orders.reduce((sum: number, o: any) => sum + Number(o.total), 0);
        const totalOrders = orders.length;
        const totalProducts = products.length;
        const totalUsers = users.length;
        
        setStats({
          totalSales,
          totalOrders,
          totalProducts,
          totalUsers,
          recentOrders: orders.slice(0, 5) // top 5
        });
      } catch (err) {
         console.error(err);
      } finally {
        setLoading(false);
      }
    };
    fetchDashboardData();
  }, []);

  return (
    <div className="flex min-h-screen bg-[#FDF8F3]">
      <AdminSidebar />
      <main className="flex-grow md:pl-64 p-4 md:p-8">
        <div className="flex justify-between items-center mb-10">
          <h1 className="text-3xl font-black text-coffee-950">Dashboard Overview</h1>
          <div className="flex items-center space-x-4">
             <span className="text-sm font-bold text-coffee-400">{new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric'})}</span>
          </div>
        </div>

        {loading ? (
           <p className="text-coffee-500 animate-pulse">Loading analytics...</p>
        ) : (
          <>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
              <div className="bg-white p-8 rounded-[2rem] border border-coffee-50 shadow-sm hover:shadow-lg transition-all">
                <div className="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex flex-col items-center justify-center mb-6">
                  <DollarSign className="h-6 w-6" />
                </div>
                <p className="text-coffee-400 font-bold uppercase text-xs tracking-widest mb-2">Total Revenue</p>
                <h2 className="text-4xl font-black text-coffee-950">₱{stats.totalSales.toFixed(2)}</h2>
              </div>
              <div className="bg-white p-8 rounded-[2rem] border border-coffee-50 shadow-sm hover:shadow-lg transition-all">
                <div className="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex flex-col items-center justify-center mb-6">
                  <ShoppingBag className="h-6 w-6" />
                </div>
                <p className="text-coffee-400 font-bold uppercase text-xs tracking-widest mb-2">Total Orders</p>
                <h2 className="text-4xl font-black text-coffee-950">{stats.totalOrders}</h2>
              </div>
              <div className="bg-white p-8 rounded-[2rem] border border-coffee-50 shadow-sm hover:shadow-lg transition-all">
                <div className="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex flex-col items-center justify-center mb-6">
                  <Package className="h-6 w-6" />
                </div>
                <p className="text-coffee-400 font-bold uppercase text-xs tracking-widest mb-2">Menu Products</p>
                <h2 className="text-4xl font-black text-coffee-950">{stats.totalProducts}</h2>
              </div>
              <div className="bg-white p-8 rounded-[2rem] border border-coffee-50 shadow-sm hover:shadow-lg transition-all">
                <div className="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex flex-col items-center justify-center mb-6">
                  <UsersIcon className="h-6 w-6" />
                </div>
                <p className="text-coffee-400 font-bold uppercase text-xs tracking-widest mb-2">Total Users</p>
                <h2 className="text-4xl font-black text-coffee-950">{stats.totalUsers}</h2>
              </div>
            </div>

            <div className="bg-white rounded-[2.5rem] p-8 border border-coffee-50 shadow-sm">
               <h3 className="text-xl font-black text-coffee-950 mb-8 border-b border-coffee-50 pb-4">Recent Orders</h3>
               {stats.recentOrders.length === 0 ? (
                 <p className="text-coffee-400 py-10 text-center font-medium">No recent orders yet.</p>
               ) : (
                 <div className="space-y-6">
                    {stats.recentOrders.map((order, i) => (
                      <div key={i} className="flex justify-between items-center group p-4 hover:bg-cream-50 rounded-2xl transition-colors">
                        <div className="flex items-center space-x-6">
                           <div className={`w-12 h-12 rounded-xl flex items-center justify-center ${order.status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'}`}>
                              {order.status === 'completed' ? <CheckCircle className="h-6 w-6" /> : <Clock className="h-6 w-6" />}
                           </div>
                           <div>
                              <p className="font-bold text-coffee-950 text-lg uppercase">#ORD-{order.id.toString().padStart(4, '0')}</p>
                              <p className="text-xs font-bold text-coffee-400 mt-1 uppercase tracking-widest">
                                {new Date(order.createdAt).toLocaleString()} • {order.items?.length || 0} Items
                              </p>
                           </div>
                        </div>
                        <div className="text-right">
                           <p className="text-xl font-black text-[#D4A373]">₱{(Number(order.total) || 0).toFixed(2)}</p>
                           <p className={`text-[10px] font-black uppercase tracking-widest mt-1 ${order.status === 'completed' ? 'text-green-500' : 'text-yellow-500'}`}>{order.status}</p>
                        </div>
                      </div>
                    ))}
                 </div>
               )}
            </div>
          </>
        )}
      </main>
    </div>
  );
}
