"use client";
import React, { useState, useEffect } from 'react';
import AdminSidebar from '@/components/AdminSidebar';
import { Eye, Loader2, Search, CheckCircle, Clock } from 'lucide-react';
import { useRouter } from 'next/navigation';

export default function AdminOrdersPage() {
  const router = useRouter();
  const [orders, setOrders] = useState<any[]>([]);
  const [search, setSearch] = useState('');
  const [loading, setLoading] = useState(true);

  const fetchOrders = async () => {
    try {
      const res = await fetch('/api/admin/orders');
      if (res.ok) {
        const data = await res.json();
        setOrders(data);
      }
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchOrders();
  }, []);

  const markCompleted = async (id: number) => {
    try {
      const res = await fetch(`/api/orders/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: 'completed' })
      });
      if (res.ok) fetchOrders();
    } catch (err) {
      console.error(err);
    }
  };

  const filteredOrders = orders.filter(o => 
    o.id.toString().includes(search) || 
    (o.user?.name && o.user.name.toLowerCase().includes(search.toLowerCase()))
  );

  return (
    <div className="flex min-h-screen bg-[#FDF8F3]">
      <AdminSidebar />
      <main className="flex-grow md:pl-64 p-4 md:p-8">
        <div className="flex justify-between items-center mb-10">
          <h1 className="text-3xl font-black text-coffee-950">Orders Management</h1>
          <div className="relative">
             <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-300" />
             <input 
               type="text" 
               placeholder="Search Order ID or Customer..." 
               value={search}
               onChange={(e) => setSearch(e.target.value)}
               className="bg-white border border-coffee-100 rounded-xl py-3 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#C69276] shadow-sm w-[300px]" 
             />
          </div>
        </div>

        <div className="bg-white rounded-[2.5rem] p-8 border border-coffee-50 shadow-sm overflow-x-auto">
          {loading ? (
             <div className="flex justify-center items-center py-20">
               <Loader2 className="h-10 w-10 text-coffee-300 animate-spin" />
             </div>
          ) : filteredOrders.length === 0 ? (
             <p className="text-center text-coffee-400 py-10 font-bold uppercase tracking-widest text-xs">No orders found.</p>
          ) : (
            <table className="w-full text-left min-w-[800px]">
              <thead>
                <tr className="border-b border-coffee-50 text-coffee-300 text-xs font-black uppercase tracking-widest">
                  <th className="pb-4 pt-2">Order ID</th>
                  <th className="pb-4 pt-2">Customer</th>
                  <th className="pb-4 pt-2">Date</th>
                  <th className="pb-4 pt-2">Items</th>
                  <th className="pb-4 pt-2 text-right">Total</th>
                  <th className="pb-4 pt-2 pl-6">Status</th>
                  <th className="pb-4 pt-2 text-center">Actions</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-coffee-50">
                {filteredOrders.map(order => (
                  <tr key={order.id} className="group hover:bg-cream-50/50 transition-colors">
                    <td className="py-5 text-sm font-black text-coffee-950">#ORD-{order.id.toString().padStart(4, '0')}</td>
                    <td className="py-5 text-sm font-bold text-coffee-600">
                      {order.user?.name || "Guest User"}
                      <span className="block text-xs text-coffee-300 font-normal">{order.user?.email || "N/A"}</span>
                    </td>
                    <td className="py-5 text-xs font-bold text-coffee-400">{new Date(order.createdAt).toLocaleString()}</td>
                    <td className="py-5 text-sm font-black text-coffee-400">{order.items?.length || 0}</td>
                    <td className="py-5 text-sm font-black text-[#D4A373] text-right">₱{(Number(order.total) || 0).toFixed(2)}</td>
                    <td className="py-5 pl-6">
                       <span className={`px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest flex items-center inline-flex space-x-2 ${
                         order.status === 'completed' ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600'
                       }`}>
                         {order.status === 'completed' ? <CheckCircle className="h-3 w-3" /> : <Clock className="h-3 w-3" />}
                         <span>{order.status}</span>
                       </span>
                    </td>
                    <td className="py-5 text-center">
                       <div className="flex items-center justify-center space-x-2">
                         {order.status !== 'completed' && (
                            <button 
                              title="Mark as Completed"
                              onClick={() => markCompleted(order.id)} 
                              className="p-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all shadow-sm group-hover:shadow-md"
                            >
                              <CheckCircle className="h-4 w-4" />
                            </button>
                         )}
                         <button 
                             title="View Receipt"
                             onClick={() => router.push(`/orders/${order.id}`)}
                             className="p-2 bg-coffee-800 text-white rounded-xl hover:bg-coffee-900 transition-all shadow-sm group-hover:shadow-md"
                         >
                            <Eye className="h-4 w-4" />
                         </button>
                       </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </main>
    </div>
  );
}
